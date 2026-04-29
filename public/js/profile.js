$(document).ready(function () {

    const pathname = window.location.pathname;

    // --------------------GLOBAL--------------------

    $("#copyMeetingLink").on("click", function () {
        navigator.clipboard.writeText(this.getAttribute("data-link"));
        $('.copy-text').text(languages.copied_text);
        setTimeout(() => {
            $('.copy-text').text(languages.copy_link);
        }, 2000);
    });

    setTimeout(function () {
        $('#success-alert').fadeOut(500, function () {
            $(this).remove();
        });
    }, 3000);

    function showToast(message, type = "success") {
        const targetDiv = document.querySelector('.showToastAbove');

        if (!targetDiv) {
            return;
        }

        const alert = document.createElement('div');
        if (type == "error") {
            alert.className = 'alert alert-danger alert-dismissible fade show';
        } else {
            alert.className = 'alert alert-success alert-dismissible fade show';
        }
        alert.role = 'alert';
        alert.innerHTML =
            message;

        targetDiv.parentNode.insertBefore(alert, targetDiv);

        setTimeout(() => {
            alert.classList.remove('show');
            alert.classList.add('fade');
            setTimeout(() => alert.remove(), 500);
        }, 3000);
    }

    // -----------------------PROFILE AVATAR------------------------

    if (pathname == "/profile/basic") {
        let cropper;
        const modelImage = document.getElementById('previewImage');
        const modal = $('#previewModal');

        $("document").ready(function () {
            $('#change-avatar').on('click', function (e) {
                e.preventDefault();
                $('#avatarchange').click();
            });

            //listen on avatar remove event
            $('#removeAvatar').on('click', function () {
                $(this).attr('disabled', true);

                $.ajax({
                    url: "delete-avatar",
                    data: {
                        id: $('#userid').val()
                    },
                    type: "post",
                })
                    .done(function (data) {
                        data = JSON.parse(data);

                        if (data.success) {
                            showToast('Profile Deleted Successfully.');
                            setTimeout(function () {
                                window.location.reload();
                            }, 1000);

                        } else {
                            showError(data.error);
                        }

                        $('#removeAvatar').attr('disabled', false);
                    })
                    .catch(function () {
                        $('#removeAvatar').attr('disabled', false);
                        showError(languages.error_occurred);
                    });
            });

        });

        //handle avatar change
        $(document).on("change", "#avatarchange", function (e) {
            var files = e.target.files;
            if (files && files.length > 0) {
                var url = URL.createObjectURL(files[0]);
                modelImage.src = url;
                modal.modal('show');
            }
        });

        //handle avatar preview modal toggle
        modal.on('shown.bs.modal', function () {
            cropper = new Cropper(modelImage, {
                aspectRatio: 1,
                viewMode: 2,
                responsive: true,
                minContainerWidth: 465,
                minContainerHeight: 200,
                minCanvasWidth: 465,
                minCanvasHeight: 200,
                minCropBoxWidth: 465,
                minCropBoxHeight: 200,
                preview: '.preview'
            });
        }).on('hidden.bs.modal', function () {
            cropper.destroy();
            cropper = null;
        });

        //crop and upload avatar
        $("#crop_button").on('click', function () {
            const imgurl = cropper.getCroppedCanvas().toDataURL();

            $(this).attr('disabled', true);

            cropper.getCroppedCanvas().toBlob((blob) => {
                const formData = new FormData();
                formData.append('image', blob);
                formData.append('extension', blob.type.replace("image/", " "));
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "upload-avatar",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        if (data.success) {
                            modal.modal('hide');

                            showToast(data.message);
                            setTimeout(function () {
                                window.location.reload();
                            }, 1000);
                        } else {
                            showToast(data.message);
                        }
                    },
                    complete: function () {
                        $("#crop_button").attr('disabled', true);
                    }
                });
            })
        });
    }

    // ---------------------API TOKEN COPY------------------------

    if (pathname == "/profile/api-token") {
        $(".copyApiTokenButton").on("click", function () {
            let token = $(this).data("token");
            let inp = document.createElement("textarea");
            inp.style.position = "absolute";
            inp.style.left = "-9999px";
            document.body.appendChild(inp);
            inp.value = token;
            inp.select();
            document.execCommand("copy");
            inp.remove();
            showToast(languages.api_token_copied);
        });
    }

    // -----------------------TOGGLE TFA------------------------
    if (pathname == "/profile/tfa") {
        //update user status via dropdown
        $(document).on("change", ".toggle-user-tfa", function () {
            const toggleTfa = $(this);
            toggleTfa.prop("disabled", true);

            const userTfa = $(this).prop("checked") ? "active" : "inactive";
            const userId = $(this).data("id");

            $.ajax({
                type: "POST",
                url: "/profile/update-tfa",
                data: {
                    _token: $('meta[name="csrf-token"]').attr("content"),
                    userTfa,
                    userId,
                },
                success: function (response) {
                    if (response.success) {
                        showToast(response.message);
                    } else {
                        showToast(response.message, 'error');
                    }
                },
                error: function (xhr, status, error) {
                    showToast("Something went wrong, please try again!");
                },
                complete: function () {
                    toggleTfa.prop("disabled", false);
                },
            });
        });
    }
});
