$(document).ready(function () {
    // edit__order();
});
function edit__order() {
    bkLib.onDomLoaded(function() {
        nicEditors.editors.push(
            new nicEditor({
                buttonList:['bold',
                    'italic',
                    'underline',
                    'left',
                    'center',
                    'right',
                    'justify',
                    'ol',
                    'ul',
                    'fontSize',
                    'indent',
                    'outdent',
                    'link' ,
                    'unlink',
                    'forecolor',
                    'bgcolor'
                ]
            }).panelInstance(
                document.getElementById('myNicEditor')
            )
        );
    });
}
