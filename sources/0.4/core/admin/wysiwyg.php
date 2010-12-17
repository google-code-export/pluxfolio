<?php

/**
 * Edition d'un article
 *
 * @package PLX
 * @author	Stephane F et Florent MONTHEL
 **/

include('prepend.php');

$wysiwyg_panel = '<p class="wysiwyg">
							
				<a onclick="return insert_text(\'b\');"><sub><img alt="Полужирное" title="Полужирное" src="'.PLX_ROOT.'/core/admin/img/edit-bold.png"></sub></a>&nbsp;
				<a onclick="return insert_text(\'i\');"><sub><img alt="Наклонное" title="Наклонное" src="'.PLX_ROOT.'/core/admin/img/edit-italic.png"></sub></a>&nbsp;
				<a onclick="return insert_text(\'u\');"><sub><img alt="Подчеркнутое" title="Подчеркнутое" src="'.PLX_ROOT.'/core/admin/img/edit-underline.png"></sub></a>&nbsp;
				<a onclick="return insert_text(\'sup\');"><sub><img alt="Степень" title="Степень" src="'.PLX_ROOT.'/core/admin/img/edit-superscript.png"></sub></a>&nbsp;
				<a onclick="return insert_text(\'sub\');"><sub><img alt="Основание" title="Основание" src="'.PLX_ROOT.'/core/admin/img/edit-subscript.png"></sub></a>&nbsp;
				<a onclick="return insert_text(\'strike\');"><sub><img alt="Основание" title="Основание" src="'.PLX_ROOT.'/core/admin/img/edit-strike.png"></sub></a>&nbsp;

				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

				<a onclick="return insert_text(\'h2\');"><sub><img alt="Заголовок" title="Заголовок" src="'.PLX_ROOT.'/core/admin/img/edit-heading.png"></sub></a>&nbsp;
				<a onclick="return insert_text(\'p\');"><sub><img alt="Параграф" title="Параграф" src="'.PLX_ROOT.'/core/admin/img/edit-paragraph.png"></sub></a>&nbsp;
				<a onclick="return insert_text(\'blockquote\');"><sub><img alt="Цитата" title="Цитата" src="'.PLX_ROOT.'/core/admin/img/edit-quotation.png"></sub></a>&nbsp;

				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

				<a onclick="insert_link(); return false;"><sub><img alt="Ссылка" title="Ссылка" src="'.PLX_ROOT.'/core/admin/img/chain.png"></sub></a>&nbsp;
				<a onclick="insert_image(); return false;"><sub><img alt="Картинка" title="Картинка" src="'.PLX_ROOT.'/core/admin/img/image.png"></sub></a>&nbsp;

		</p>'

; ?>
