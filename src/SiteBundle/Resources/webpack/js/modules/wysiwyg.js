import {postXHRJson} from 'mkksite/js/modules/xhr/postXHRJson'
import tinyMCE from 'tinymce'
import 'tinymce/themes/modern'
import 'tinymce/plugins/advlist'
import 'tinymce/plugins/anchor'
import 'tinymce/plugins/autolink'
import 'tinymce/plugins/autoresize'
import 'tinymce/plugins/autosave'
import 'tinymce/plugins/bbcode'
import 'tinymce/plugins/charmap'
import 'tinymce/plugins/code'
import 'tinymce/plugins/codesample'
import 'tinymce/plugins/colorpicker'
import 'tinymce/plugins/contextmenu'
import 'tinymce/plugins/directionality'
import 'tinymce/plugins/emoticons'
import 'tinymce/plugins/fullpage'
import 'tinymce/plugins/fullscreen'
import 'tinymce/plugins/hr'
import 'tinymce/plugins/image'
import 'tinymce/plugins/imagetools'
import 'tinymce/plugins/importcss'
import 'tinymce/plugins/insertdatetime'
import 'tinymce/plugins/legacyoutput'
import 'tinymce/plugins/link'
import 'tinymce/plugins/lists'
import 'tinymce/plugins/media'
import 'tinymce/plugins/nonbreaking'
import 'tinymce/plugins/noneditable'
import 'tinymce/plugins/pagebreak'
import 'tinymce/plugins/paste'
import 'tinymce/plugins/preview'
import 'tinymce/plugins/print'
import 'tinymce/plugins/save'
import 'tinymce/plugins/searchreplace'
import 'tinymce/plugins/spellchecker'
import 'tinymce/plugins/tabfocus'
import 'tinymce/plugins/table'
import 'tinymce/plugins/template'
import 'tinymce/plugins/textcolor'
import 'tinymce/plugins/textpattern'
import 'tinymce/plugins/toc'
import 'tinymce/plugins/visualblocks'
import 'tinymce/plugins/visualchars'
import 'tinymce/plugins/wordcount'
// File loader that handles moving the skin files
require.context(
	'file-loader?name=[path][name].[ext]&context=node_modules/tinymce!tinymce/skins',
	true,
	/.*/
)

class Wysiwyg
{
	async getFileManager (url, datapost)
	{
		if (this.recupererurl === 0)
		{
			let datawysiwyg = await postXHRJson(url, datapost, 0)

			this.recupererurl = 1
			this.datawysiwyg = datawysiwyg
			this.remplir(datawysiwyg)
		}
		else
		{
			this.remplir(this.datawysiwyg)
		}
	}
	remplir (datawysiwyg)
	{
		let lang = 'fr_FR'

		require('tinymce-i18n/langs/' + lang)
		let data = {
			'lang'                  : lang,
			'theme'                 : 'modern',
			'image_advtab'          : true,
			'menubar'               : 'edit insert view tools',
			'selector'              : '.wysiwyg',
			'relative_urls'         : true,
			'remove_script_host'    : false,
			'init_instance_callback': function (ed)
			{
				if ($('#' + ed.id).attr('maxlength'))
				{
					let maxlength = $('#' + ed.id).attr('maxlength')
					let total = maxlength - ed.getContent(
						{
							'format': 'text'
						}
					).length
					let statusbar = $(ed.getContainer()).find('.mce-statusbar').find('div')

					statusbar.find('.mce-path').after($('.mce-lettercount'))
					statusbar.find('.mce-lettercount').find('span').html(total)
					if (total < 0)
					{
						statusbar.find('.mce-lettercount').addClass('negatif')
					}
					ed.on(
						'keyup',
						function()
						{
							let total = maxlength - ed.getContent(
								{
									'format': 'text'
								}
							).length

							if (total < 0)
							{
								statusbar.find('.mce-lettercount').addClass('negatif')
							}
							else
							{
								statusbar.find('.mce-lettercount').removeClass('negatif')
							}
							statusbar.find('.mce-lettercount').find('span').html(total)
						}
					)
				}
			}
		}

		data = $.extend(data, datawysiwyg, {} )
		tinyMCE.init(data)
	}
	constructor ()
	{
		this.recupererurl = 0
		this.datawysiwyg = 0
		this.setTinymce()
	}
	setTinymce ()
	{
		if ($('.wysiwyg').length !== 0)
		{
			let $textarea = $('.wysiwyg')
			let url = $($textarea[0]).data('url')
			let id = $($textarea[0]).attr('id')
			let css = $($textarea[0]).data('css')
			let form = $($textarea[0]).closest('form').attr('id')
			let module = $('body').data('module')
			let route = $('body').data('route')
			let datapost = {
				'language': $('html').attr('lang'),
				'css'     : css,
				'url'     : url,
				'id'      : id,
				'form'    : form,
				'module'  : module,
				'route'   : route
			}

			this.getFileManager(url, datapost)
		}
	}
}

export {Wysiwyg}
