var editor_config = {
    license_key: "gpl",
    path_absolute: "/",
    selector: "textarea.tinymce",
    height: 800,
    plugins: "link image media table code",
    toolbar:
        "undo redo | styleselect | bold italic | alignleft aligncenter alignright | bullist numlist | link image media | code ",
    relative_urls: false,
    file_picker_callback: function (callback, value, meta) {
        var x =
            window.innerWidth ||
            document.documentElement.clientWidth ||
            document.body.clientWidth;
        var y =
            window.innerHeight ||
            document.documentElement.clientHeight ||
            document.body.clientHeight;

        var cmsURL =
            editor_config.path_absolute +
            "laravel-filemanager?editor=" +
            meta.fieldname;
        if (meta.filetype == "image") {
            cmsURL = cmsURL + "&type=Images";
        } else {
            cmsURL = cmsURL + "&type=Files";
        }

        tinyMCE.activeEditor.windowManager.openUrl({
            url: cmsURL,
            title: "Quản lý tập tin",
            width: x * 0.8,
            height: y * 0.8,
            resizable: "yes",
            close_previous: "no",
            onMessage: (api, message) => {
                callback(message.content);
            },
        });
    },
};
tinymce.init(editor_config);

$(function () {
    $('input[name="datefilter"]').daterangepicker({
        autoUpdateInput: false,
        locale: {
            cancelLabel: "Clear",
        },
    });

    $('input[name="datefilter"]').on(
        "apply.daterangepicker",
        function (ev, picker) {
            $(this).val(
                picker.startDate.format("MM/DD/YYYY") +
                    " - " +
                    picker.endDate.format("MM/DD/YYYY")
            );
        }
    );

    $('input[name="datefilter"]').on(
        "cancel.daterangepicker",
        function (ev, picker) {
            $(this).val("");
        }
    );
});
