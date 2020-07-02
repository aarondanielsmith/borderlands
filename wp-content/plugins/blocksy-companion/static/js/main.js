import { mountAccount } from './frontend/account'

export const onDocumentLoaded = cb => {
	if (/comp|inter|loaded/.test(document.readyState)) {
		cb()
	} else {
		document.addEventListener('DOMContentLoaded', cb, false)
	}
}

onDocumentLoaded(() => {
	mountAccount()
})
