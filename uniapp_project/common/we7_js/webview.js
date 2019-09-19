import App from '../../App'
const app = App;
let backApp = function (url) {
	if (url) {
		try {
			wx.setStorageSync('we7_webview', url)
		} catch (e) {
			console.log(e)
		}
	}
	var pages = getCurrentPages();
	if (pages.length > 1) {
		for (var i in pages) {
			if (pages[i]['__route__'] === 'wn_storex/pages/view/index') {
				wx.navigateBack({
					data: pages.length - i + 1
				})
			}
		}
	}
};

let urlAddCode = function (url) {
	let userInfo = wx.getStorageSync('userInfo');
	let addCode = function (response) {
		let state = getQueryString(url, 'state');
		if (!url.indexOf('http') && !state) {
			url = url.replace(/index.php\?/,"index.php?from=wxapp&state=we7sid-" + response.sessionid + '&')
		}
		let _this = getCurrentPages();
		if (_this) {
			_this = _this[getCurrentPages().length - 1];
		}
		_this.setData({
			url: url
		});
	};
	if (!userInfo.sessionid) {
		app.util.getUserInfo(addCode)
	} else {
		addCode(userInfo)
	}

};

function getQueryString(url, name) {
	url = url.replace(/(#\/)(.*)/, '');
	let reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
	let r = url.match(reg);
	if (r !== null) {
		return unescape(r[2]);
	}
	return null;
}

module.exports = {
	backApp, urlAddCode
};