<script language="javascript" type="text/javascript" src="editor/tiny_mce/tiny_mce.js"></script>
<script language="javascript" type="text/javascript">
        tinyMCE.init({
				language : "ru",
                mode : "exact",
                elements : "<?php echo $editorname;?>",
                theme : "advanced",

                plugins : "youtube,media,table,insertdatetime,preview,searchreplace,print,contextmenu,paste",

                theme_advanced_buttons1_add_before : "newdocument,separator",
                theme_advanced_buttons1_add : "separator,forecolor,backcolor",
                theme_advanced_buttons2_add : "separator,insertdate,inserttime,preview",
                theme_advanced_buttons2_add_before: "cut,copy,paste,pastetext,pasteword,separator,search,replace,separator",
                theme_advanced_buttons3_add_before : "tablecontrols,separator",
                theme_advanced_buttons3_add : "youtube,media,code,separator,print",

                theme_advanced_disable: "cleanup,help,formatselect,anchor,code",

                theme_advanced_toolbar_location : "top",
                theme_advanced_toolbar_align : "left",
                theme_advanced_path_location : "bottom",
                content_css : "editor/full.css",
                plugin_preview_width : "500",
                plugin_preview_height : "600",
            plugin_insertdate_dateFormat : "%Y-%m-%d",
            plugin_insertdate_timeFormat : "%H:%M:%S",
                extended_valid_elements : "hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style],object[width|height|classid|codebase|embed|param],param[name|value],embed[param|src|type|width|height|flashvars|wmode]",
//                external_link_list_url : "MCE/example_link_list.js",
//                external_image_list_url : "MCE/example_image_list.js",
//                flash_external_list_url : "MCE/example_flash_list.js",
//                file_browser_callback : "fileBrowserCallBack",
                theme_advanced_resize_horizontal : false,
                theme_advanced_resizing : true,
                apply_source_formatting : true
        });
</script>