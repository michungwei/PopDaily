// JavaScript Document
//使用法:改此檔+php上傳檔

var img_href = "../../upload/newscontent/";
/*var img_href = "http://onecentimetre.com/upload/newscontent/";/圖片位置!需依需求更改為正確絕對路徑!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!*/
$.getScript( "../../ui/uploadify/jquery.uploadify.min.js"); /*加载uploadify 插件 ，地址根据需求更改!!!!!!!!!!!!!!!!*/

window.ck_tmp_image_src = '';
CKEDITOR.dialog.add( 'uploadImage', function (editor) {
    return {
        title: '多圖上傳', // 對話框標題
        minWidth: 500,    // 對話框寬度
        minHeight: 300,   // 對話框高度
        contents: [{
            id: 'tab-upload',
            label: '選擇圖片',
            elements: [        
                {
                    type: 'file',  //添加一个文本按钮元素
                    id: 'upload',  //给这个元素增加id
                    label:'請稍後...', //给其label增加内容
                    className:'CK-upload', //给其增加class值
                    labelStyle:'display:block; text-align:center;', //label的样式
                    controlStyle:'display:none', //元素的样式
                }
            ]
        }

        ],
		
		
        onLoad: function(){ // 当对话框显示时执行的函数
            setTimeout(function(){  //因对话框内容加载有一点延时，所以这里也做延时处理
                var uploadClone = $('.CK-upload');  //获取文件按钮JQ对象
                $('.CK-upload').uploadify({ //初始化uploadify
				    'debug'    : false,
					'multi'    : true,
			        'method'   : 'post',
				    'auto'     : true,
				    'width'    : 'auto',
				    'height'    : '187px',
				    'fileTypeDesc' : 'Image Files',
        		    'fileTypeExts' : '*.gif; *.jpg; *.png',
				    'fileSizeLimit' : '3MB', 
				    'buttonText': '點擊選擇圖片',
				    'swf': '../../ui/uploadify/uploadify.swf',
				    'uploader': 'uploadify.php',/*處理上傳圖片的php檔!!!!!!!!!!!!!!!!!!!!!!!!!!*/
					
					
					/*'swf': '',
				    'uploader' : '',
                    'height': 187,
                    'buttonText':'上傳',
                    'width': 187,*/
					
                    'onInit':function(instance){
                        /*$('.uploadify').css({
                            border: '1px solid #999999',
                            'border-radius': '5px',
                            'height': '19px',
                            'text-align': 'center',
                            'width': '120px'
							//'margin-left': '166px',
                           // margin-top': '75px',
                            //padding': '5px 15px',
                        })*/
                        $('#SWFUpload_0').css({'width':'500px','height':'32px','left':'0px','top':'0px'});
                        $('.uploadify-button').append(uploadClone);
						/*$('.uploadify-button').css({'text-align': 'center'});*/
                        $('.uploadify-queue').remove();
                        uploadClone.css({display:'none'});
                        //TODO set the upload button
						
					   $("<div/>", {
						   "class": "uploadifystate",
					   }).appendTo(".uploadify");
					   $("<div/>", {
						   "class": "uploadifystate_0",
					   }).appendTo(".uploadify");
                    },
					
                    
					'onUploadSuccess':function(file,data){
                        //TODO add content to the ckeditor content

                         //ck_tmp_image_src = file.name; // 设置服务器返回的链接地址
						 //alert(file.name + ' 文件上传完成.');
						  
						 //创建一个ck 图片元素
						 var element = CKEDITOR.dom.element.createFromHtml('<img src="'+img_href+data+'" />',editor.document);
						 //将图片元素插入到当前CK-editor光标处
						 editor.insertElement(element);
						 
						 $("<div/>", {
						   "class": "uploadifystate_0",
						   "id": "uploadifystate_0",
						   "html":file.name+"&nbsp;&nbsp;&nbsp;...上傳ok",
					   }).appendTo(".uploadify");
						 
                    },

					'onUploadProgress':function(file, bytesUploaded, bytesTotal, totalBytesUploaded, totalBytesTotal){
						$(".uploadifystate").html("檔案上傳中&nbsp;:&nbsp;&nbsp;"+totalBytesUploaded+" / "+totalBytesTotal+"&nbsp;&nbsp;&nbsp;&nbsp;完成後視窗將自動關閉")
					},
					
					
					'onQueueComplete' : function() {
						$(".uploadifystate").html("");//將進度條清空
						$(".uploadifystate_0").remove();//將上傳Ok通知刪除
						$('.cke_dialog_ui_button').click(); //成功并提交对话框
					}

					
					
					
					
                });

            },1500)
        },
        onOk:function(){ //提交对话框时进行的操作
           
            window.ck_tmp_image_src = ''; //重置全局变量
        }
    };
});