function getXHRJson (url)
{
	return new Promise(
		function (resolve)
		{
			$.get(
				url,
				resolve,
				'json'
			)
		}
	)
}
export {getXHRJson}
