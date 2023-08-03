import ClassicEditor from "../../libs/@ckeditor/ckeditor5-build-classic/build/ckeditor";

const ckeditorClassic = document.querySelector("#ckeditor-classic");
ckeditorClassic && ClassicEditor.create(document.querySelector("#ckeditor-classic")).then(function (e) {
    e.ui.view.editable.element.style.height = "200px"
}).catch(function (e) {
    console.error(e)
});

let previewTemplate, dropzone, dropzonePreviewNode = document.querySelector("#dropzone-preview-list");
dropzonePreviewNode && (dropzonePreviewNode.id = "", previewTemplate = dropzonePreviewNode.parentNode.innerHTML, dropzonePreviewNode.parentNode.removeChild(dropzonePreviewNode), dropzone = new Dropzone(".dropzone", {
    dictDefaultMessage: "Déposer des fichiers ici pour télécharger",
    url: "https://httpbin.org/post",
    method: "post",
    previewTemplate: previewTemplate,
    previewsContainer: "#dropzone-preview"
}));