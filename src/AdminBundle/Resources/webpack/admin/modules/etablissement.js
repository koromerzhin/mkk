export class Etablissement
{
	BoutonNewEtablissement (event)
	{
		event.preventDefault()
		$('#PopupNewEtablissement').modal('toggle')
	}

	constructor ()
	{
		$('#BoutonNewEtablissement,#LienAjouterEtablissement').on('click', this.BoutonNewEtablissement.bind(this))
	}
}
