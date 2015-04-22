CKEDITOR.plugins.add('CodePlugin',
{
    init: function (editor) {
        // Add the link and unlink buttons.
        editor.addCommand('CodePlugin', new CKEDITOR.dialogCommand('CodePlugin')); //定義dialog，也就是下面的code
        editor.ui.addButton('Code',     //定義button的名稱及圖片,以及按下後彈出的dialog
        {                               //這裡將button名字取叫'Code'，因此剛剛上方的toolbar也是加入名為Code的按鈕
            label: '插入程式碼',
            icon: 'plugins/CodePlugin/icon/1.png',
            command: 'CodePlugin'
        });
        //CKEDITOR.dialog.add( 'link’, this.path + 'dialogs/link.js’ ); 
        //dialog也可用抽離出去變一個js，不過這裡我直接寫在下面
        CKEDITOR.dialog.add('CodePlugin', function (editor) {      
        //以下開始定義dialog的屬性及事件          
            return {                        //定義簡單的title及寬高
                title: '插入程式碼',
                minWidth: 500,
                minHeight: 400,
                contents: [              
                    {
                        id: 'code',
                        label: 'code',
                        title: 'code',
                        elements:              //elements是定義dialog內部的元件，除了下面用到的select跟textarea之外
                            [                  //還有像radio或是file之類的可以選擇
                            /*{
                                type: 'select',
                                label: 'Language',
                                id: 'language',
                                //required: true,
                                'default': 'csharp',
                                items: [['C#', 'csharp'], ['CSS', 'css'], ['Html', 'xhtml'], ['JavaScript', 'js'], ['SQL', 'sql'], ['XML', 'xml']]
                            }
                            ,*/ {
                                id: 'codecontent',
                                type: 'textarea',
                                label: '請輸入程式碼',
                                style: 'width:700px;height:500px',
                                rows: 30,
                                'default': ''
                            }
                            ]
                    }
                    ],
                onOk: function () {                                    
                    //當按下ok鈕時,將上方定義的元件值取出來，利用insertHtml
                    //將組好的字串插入ckeditor的內容中
                     code = this.getValueOf('code', 'codecontent');    
                     /*lang = this.getValueOf('code', 'language');*/
                     editor.insertHtml("<pre>" + code + "</pre>");
                }
           };  
       });
    }
})