import {Country} from './form/country'
import {DatePicker} from './form/datepicker'
import {Login} from './form/login'
import {Upload} from './form/upload'
import {Submit} from './form/submit'
import {SearchInput} from './form/searchInput'
import {Select2} from './form/select2'
export class Form
{
	OnKeyUpInput (event)
	{
		if (event.which === 13)
		{
			$(this).trigger('blur')
		}
	}
	inputKeyUp ()
	{
		$('input').on('keyup', this.OnKeyUpInput)
	}

	boutonSaveAndCloseOnClick ()
	{
		$('#BoutonSaveAndClose').attr('data-close', 1)
		let url

		if ($('#BoutonReturn').length)
		{
			url = $('#BoutonReturn').attr('href')
		}
		else
		{
			url = $('#BoutonDashboard').attr('href')
		}
		$('input[name=\'_view\']').val(url)
		$('#BoutonSave').trigger('click')
	}

	boutonSaveAndClose ()
	{
		$('#BoutonSaveAndClose').attr('data-close', 0)
		$('#BoutonSaveAndClose').on('click', this.boutonSaveAndCloseOnClick)
	}
	ClickActionSearch ()
	{
		let param = $('#FormSearch').serializeForm()
		let url = $('#FormSearch').attr('action')

		if (param !== '')
		{
			url = url + '?' + this.param(param)
			document.location = url
		}
		return false
	}
	param (data)
	{
		let url = ''

		for (let iterator in data)
		{
			if (data[iterator] !== '')
			{
				if (url !== '')
				{
					url = url + '&'
				}
				url = url + iterator + '=' + data[iterator]
			}
		}
		return url
	}
	search ()
	{
		let parent = this

		$('input').each(
			function()
			{
				if ($(this).attr('data-url') !== undefined && $(this).closest('.modal').html() === undefined)
				{
					parent.searchInput.traiter(this)
				}
			}
		)
		$('.BtnSearch').on('click', this.ClickActionSearch.bind(this))
	}
	champsObligatoire ()
	{
		$('label.required').each(
			function()
			{
				if ($(this).closest('.modal').html() === undefined)
				{
					$('#ChampsObligatoireToolbar').show()
				}
			}
		)
	}
	checkboxAll ()
	{
		$('[data-rel=\'selectionall\']').on('click', this.ClickSelectAll)
	}
	OnclickInputNumber ()
	{
		$(this).select()
	}
	selectInputNumber ()
	{
		$('input[type=\'number\']').on('click', this.OnclickInputNumber)
	}
	getDatePicker ()
	{
		return this.DatePicker
	}
	getSelect2 ()
	{
		return this.select2
	}
	constructor ()
	{
		this.Submit = new Submit()
		this.searchInput = new SearchInput()
		this.select2 = new Select2()
		this.inputKeyUp()
		this.Country = new Country()
		this.DatePicker = new DatePicker()
		this.Login = new Login()
		this.Upload = new Upload()
		this.boutonSaveAndClose()
		this.search()
		this.champsObligatoire()
		this.checkboxAll()
		this.selectInputNumber()
	}
}
