class Horaire
{
	Dupliquer (event)
	{
		let table = $(event.currentTarget).closest('table')
		let dm = ''
		let fm = ''
		let da = ''
		let fa = ''
		let tr = $(event.currentTarget).closest('tr')
		let horaireAM = $(tr).find('.HoraireAM')
		let horairePM = $(tr).find('.HorairePM')

		dm = $($(horaireAM).get(0)).val()
		fm = $($(horaireAM).get(1)).val()
		da = $($(horairePM).get(0)).val()
		fa = $($(horairePM).get(1)).val()
		$(table).find('tr').each(
			function()
			{
				horaireAM = $(this).find('.HoraireAM')
				horairePM = $(this).find('.HorairePM')
				$($(horaireAM).get(0)).val(dm)
				$($(horaireAM).get(1)).val(fm)
				$($(horairePM).get(0)).val(da)
				$($(horairePM).get(1)).val(fa)
			}
		)
		event.preventDefault()
	}
	desactiver (event)
	{
		let tr = $(event.currentTarget).closest('tr')

		$(tr).find('input').each(
			function()
			{
				$(this).val('00:00')
			}
		)
		event.preventDefault()
	}
	constructor ()
	{
		$('.HoraireDupliquer').on('click', this.Dupliquer.bind(this))
		$('.HoraireDesactiver').on('click', this.desactiver.bind(this))
	}
}
export {Horaire}
