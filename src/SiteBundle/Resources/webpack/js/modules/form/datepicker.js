export class DatePicker
{
	constructor ()
	{
		this.timeout()
		let lang = 'fr'

		require('jquery-ui/ui/i18n/datepicker-'+lang)
	}
	paques (year)
	{
		let aCalcul = year % 19
		let bCalcul = Math.floor(year / 100)
		let cCalcul = year % 100
		let dCalcul = Math.floor(bCalcul / 4)
		let eCalcul = bCalcul % 4
		let fCalcul = Math.floor((bCalcul + 8) / 25)
		let gCalcul = Math.floor((bCalcul - fCalcul + 1) / 3)
		let hCalcul = (19 * aCalcul + bCalcul - dCalcul - gCalcul + 15) % 30
		let iCalcul = Math.floor(cCalcul / 4)
		let kCalcul = cCalcul % 4
		let lCalcul = (32 + 2 * eCalcul + 2 * iCalcul - hCalcul - kCalcul) % 7
		let mCalcul = Math.floor((aCalcul + 11 * hCalcul + 22 * lCalcul) / 451)
		let n0 = hCalcul + lCalcul + 7 * mCalcul + 114
		let nCalcul = Math.floor(n0 / 31) - 1
		let pCalcul = n0 % 31 + 1
		let date = new Date(year, nCalcul, pCalcul)

		return date
	}
	VerifierJour (jour, country, ferier, joursemainedesactiver)
	{
		if (joursemainedesactiver !== '')
		{
			let day = jour.getDay()
			let tab = joursemainedesactiver.split(',')

			for (let iterator in tab)
			{
				if (tab[iterator] === day)
				{
					return [false, 'holiday-weekend', '']
				}
			}
		}
		if (ferier)
		{
			let year = jour.getFullYear()
			let paques = this.paques(year)
			let jours = new Array()
			let testday

			jours.push(paques)
			jours.push(new Date(year, paques.getMonth(), paques.getDate() + 1))
			jours.push(new Date(year, paques.getMonth(), paques.getDate() + 39))
			jours.push(new Date(year, paques.getMonth(), paques.getDate() + 49))
			jours.push(new Date(year, paques.getMonth(), paques.getDate() + 50))
			jours.push(new Date(year, 0, 1))
			jours.push(new Date(year, 4, 1))
			jours.push(new Date(year, 4, 8))
			jours.push(new Date(year, 6, 14))
			jours.push(new Date(year, 7, 15))
			jours.push(new Date(year, 10, 1))
			jours.push(new Date(year, 10, 11))
			jours.push(new Date(year, 11, 25))
			for (let iterator in jours)
			{
				testday = jours[iterator]
				if (jour.getMonth() === testday.getMonth() && jour.getDate() === testday.getDate())
				{
					return [false, 'holiday-ferier', '']
				}
			}
		}
		return [true]
	}
	calendarMaxMin (locale, min, max)
	{
		let variable = $.datepicker.regional[locale]

		variable = $.extend(
			variable,
			{
				'yearRange'         : 'c-100:c+0',
				'showAnim'          : 'slide',
				'changeMonth'       : true,
				'changeYear'        : true,
				'showWeek'          : true,
				'showOn'            : 'focus',
				'buttonText'        : '',
				'dateFormat'        : 'dd/mm/yy',
				'firstDay'          : 1,
				'isRTL'             : false,
				'showMonthAfterYear': false,
				'yearSuffix'        : '',
				'onSelect'          : function(selectedDate)
				{
					let option = $(this).attr('id') === min ? 'minDate' : 'maxDate'
					let instance = $(this).data('datepicker')
					let date = $.datepicker.parseDate(instance.settings.dateFormat || $.datepicker._defaults.dateFormat, selectedDate, instance.settings)

					$('#' + min + ', #' + max).not(this).datepicker('option', option, date)
				}
			}
		)
		$('#' + min + ', #' + max).datepicker(variable)
	}
	lancement (locale)
	{
		//this.DateTimePicker(locale)
		this.initDatePicker(locale)
		this.inputDateNaissance(locale)
	}
	initDatePicker (locale)
	{
		let minmax = []
		let variable = $.datepicker.regional[locale]

		variable = $.extend(
			variable,
			{
				'beforeShow': function(input)
				{
					let modal = $(input).closest('.modal')
					let zindex

					if (modal.html() === undefined)
					{
						zindex = 100
					}
					else
					{
						zindex = $(modal).css('z-index')
					}
					$(input).css(
						{
							'position': 'relative',
							'z-index' : zindex + 100
						}
					)
				},
				'yearRange'         : 'c-100:c+100',
				'showAnim'          : 'slide',
				'changeMonth'       : true,
				'changeYear'        : true,
				'showButtonPanel'   : true,
				'showWeek'          : true,
				'buttonText'        : '',
				'buttonImageOnly'   : false,
				'dateFormat'        : 'dd/mm/yy',
				'firstDay'          : 1,
				'isRTL'             : false,
				'showMonthAfterYear': false,
				'yearSuffix'        : ''
			}
		)
		let parent = this

		$('.datepicker').each(
			function()
			{
				if ($(this).data('datepicker') !== undefined)
				{
					let md5 = $(this).data('md5')

					if (minmax[md5] === undefined)
					{
						minmax[md5] = {
							'min': '',
							'max': ''
						}
					}
					let etat = $(this).data('datepicker')

					minmax[md5][etat] = $(this).attr('id')
					if (minmax[md5].min !== '' && minmax[md5].max !== '')
					{
						parent.calendarMaxMin(locale, minmax[md5].min, minmax[md5].max)
					}
				}
				else
				{
					$(this).datepicker(variable)
				}
			}
		)
	}
	// DateTimePicker (locale) {
	//       $('.HorairePicker').datetimepicker(
	//         {
	//           lang: locale,
	//           mask: true,
	//           datepicker: false,
	//           format: 'H:i'
	//         }
	//       )
	//       $('.HoraireAM,.HorairePM').each(
	//         function() {
	//           $(this).datetimepicker(
	//             {
	//               mask: true,
	//               datepicker: false,
	//               format: 'H:i'
	//             }
	//           )
	//         }
	//       )
	//       $(".datetimepicker").datetimepicker(
	//       {
	//         lang: locale,
	//         timepicker: true,
	//         format: 'd/m/Y H:i'
	//       }
	//       )
	// }
	timeout ()
	{
		let locale = $('html').attr('lang')

		if ($.datepicker !== undefined && $.datepicker.regional[locale] !== undefined)
		{
			this.lancement(locale)
		}
	}
	inputDateNaissance (locale)
	{
		let variable = $.datepicker.regional[locale]

		variable = $.extend(
			variable,
			{
				'beforeShow': function(input)
				{
					let modal = $(input).closest('.modal')
					let zindex

					if (modal.html() === undefined)
					{
						zindex = 100
					}
					else
					{
						zindex = $(modal).css('z-index')
					}
					$(input).css(
						{
							'position': 'relative',
							'z-index' : zindex + 100
						}
					)
				},
				'yearRange'         : 'c-100:c+100',
				'showAnim'          : 'slide',
				'changeMonth'       : true,
				'changeYear'        : true,
				'showButtonPanel'   : true,
				'showWeek'          : true,
				'buttonText'        : '',
				'buttonImageOnly'   : false,
				'dateFormat'        : 'dd/mm/yy',
				'firstDay'          : 1,
				'isRTL'             : false,
				'showMonthAfterYear': false,
				'yearSuffix'        : ''
			}
		)
		$('.DateNaissance').datepicker(variable)
	}
}
