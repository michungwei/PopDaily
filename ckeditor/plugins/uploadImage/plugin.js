// JavaScript Document
CKEDITOR.plugins.add('uploadImage',
{
    init: function (editor) {
        // Add the link and unlink buttons.
        editor.addCommand('uploadImage', new CKEDITOR.dialogCommand('uploadImage')); //定義dialog，也就是下面的code
        editor.ui.addButton('uploadImage',     //定義button的名稱及圖片,以及按下後彈出的dialog
        {                               //這裡將button名字取叫'Code'，因此剛剛上方的toolbar也是加入名為Code的按鈕
            label: '上傳多張圖片',
            icon: 'plugins/uploadImage/icon/1.png',
            command: 'uploadImage',
			
        });
		CKEDITOR.dialog.add( 'uploadImage', this.path + 'dialogs/uploadImage.js' );
        //CKEDITOR.dialog.add( 'link’, this.path + 'dialogs/link.js’ ); 
        //dialog也可用抽離出去變一個js，不過這裡我直接寫在下面
        /*CKEDITOR.dialog.add('uploadImage', function (editor) {      
        以下開始定義dialog的屬性及事件          
            return {                        //定義簡單的title及寬高
                title: '上傳多圖',
                minWidth: 500,
                minHeight: 400,
                contents: [              
                    {
                        id: 'uploadify',
                        label: 'uploadify',
                        title: 'uploadify',
                        elements:              //elements是定義dialog內部的元件，除了下面用到的select跟textarea之外
                            [                  //還有像radio或是file之類的可以選擇
                            {
                                type: 'file',
                                label: '選擇圖片',
                                id: 'img_Select',
                                required: true,
                                default': 'csharp',
                                items: [['C#', 'csharp'], ['CSS', 'css'], ['Html', 'xhtml'], ['JavaScript', 'js'], ['SQL', 'sql'], ['XML', 'xml']]
                            }
                            , {
                                id: 'uploadifycontent',
                                type: 'textarea',
                                label: '請輸入程式碼',
                                style: 'width:700px;height:500px',
                                rows: 30,
                                default': ''
                            }
                            ]
                    }
                    ],
                onOk: function () {                                    
                    當按下ok鈕時,將上方定義的元件值取出來，利用insertHtml
                    將組好的字串插入ckeditor的內容中
                     uploadify = this.getValueOf('uploadify', 'uploadifycontent');    
                     lang = this.getValueOf('uploadify', 'language');
                     editor.insertHtml("<pre class=\"brush:" + lang + ";\">" + uploadify + "</pre>");
                }
           };  
       });*/
    }
})