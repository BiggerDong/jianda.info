var ue = UE.getEditor('editor', {
    toolbars: [
        ['bold', 'italic', 'underline', '|','blockquote', 'insertunorderedlist', 'insertorderedlist', '|','simpleupload','fullscreen']
    ],
    elementPathEnabled: false,
    enableContextMenu: false,
    autoClearEmptyNode:true,
    wordCount:false,
    imagePopup:false,
    autotypeset:{ indent: true,imageBlockLine: 'center' }
});
ue.ready(function() {
    ue.execCommand('serverparam', '_token', '{{ csrf_token() }}'); // 设置 CSRF token.
});