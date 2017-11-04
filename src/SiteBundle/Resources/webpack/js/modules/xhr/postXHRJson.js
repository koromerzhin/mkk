import {traiterResponse} from './traiterResponse'
function postXHRJson (url, post, popup)
{
	if (popup === 1)
	{
		new Promise(
			function (resolve)
			{
				$.post(
					url,
					post,
					resolve,
					'json'
				)
			}
		).then(
			function (test)
			{
				traiterResponse(test)
			}
		)
	}
	else
	{
		return new Promise(
			function (resolve)
			{
				$.post(
					url,
					post,
					resolve,
					'json'
				)
			}
		)
	}
}
export {postXHRJson}
