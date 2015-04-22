/**

 * @license Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.

 * For licensing, see LICENSE.md or http://ckeditor.com/license

 */



CKEDITOR.editorConfig = function( config ) {

	// Define changes to default configuration here. For example:

	// config.language = 'fr';

	// config.uiColor = '#AADC6E';
	
    config.height = 1000;
	
	config.filebrowserUploadUrl= 'ckeditorupload.php';

	config.toolbar = 'Full';

	config.toolbar_Full =

	[

			//{ name: 'document', items : [ 'Source','-','Save','NewPage','DocProps','Preview','Print','-','Templates' ] },

			{ name: 'document', items : [ 'Source' ] },

			{ name: 'clipboard', items : [ 'Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo' ] },

			{ name: 'colors', items : [ 'TextColor','BGColor','Maximize' ] },

			{ name: 'editing', items : [ 'Find','Replace','-','SelectAll','-','SpellChecker', 'Scayt' ] },

			//{ name: 'forms', items : [ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 

			//		'HiddenField' ] },

			//'/',

			{ name: 'basicstyles', items : [ 'Bold','Italic','Underline','Strike','Subscript','Superscript','-','RemoveFormat' ] },
			{ name: 'code', items : ['Code'] },

			{ name: 'paragraph', items : [ 'NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote','CreateDiv',

			'-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-','BidiLtr','BidiRtl' ] },

			{ name: 'links', items : [ 'Link','Unlink','Anchor' ] },

			//{ name: 'insert', items : [ 'Image','Flash','Table','HorizontalRule','Smiley','SpecialChar','PageBreak','Iframe' ] },

			{ name: 'insert', items : [ 'Image','uploadImage','Table','HorizontalRule','Smiley','SpecialChar','PageBreak','Iframe' ] },//uploadImage多圖上傳按鈕，不需要可直接拿掉

			//'/',

			{ name: 'styles', items : [ 'Styles','Format','Font','FontSize' ] },
			
			{ name: 'picres', items : ['PicRes'] },

			

			//{ name: 'tools', items : [ 'Maximize', 'ShowBlocks','-','About' ] }
			
			


	];
	          config.extraPlugins = 'uploadImage,CodePlugin,PictureSource';//多圖上傳套件(uploadImage為plugins資料夾下層的資料夾名子)+插入程式碼套件
			  


	config.allowedContent = true;

};



    

