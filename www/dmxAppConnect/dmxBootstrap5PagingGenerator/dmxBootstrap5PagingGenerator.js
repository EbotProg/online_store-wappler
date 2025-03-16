(function() {

function _getPagination(m_NumPages, PageNo, m_NumOuterLinks, m_NumAdjacentLinks, m_PageLinkSeparator) {
	var pArr = [];
	if (m_NumPages < ((m_NumOuterLinks + m_NumAdjacentLinks) * 2) + 2) {
		for (var page = 1; page <= m_NumPages; page++) {
			pArr.push({title: page, page: page, active: true});
		}
	} else {
		if (PageNo < m_NumOuterLinks + m_NumAdjacentLinks + 2) {
			for (var page = 1; page <= (m_NumOuterLinks + 1) + (m_NumAdjacentLinks * 2); page++) {
				pArr.push({title: page, page: page, active: true});
			}
			if (m_NumOuterLinks > 0) {
				pArr.push({title: m_PageLinkSeparator, page: PageNo, active: false});
			}
			for (var page = m_NumPages - (m_NumOuterLinks - 1); page <= m_NumPages; page++) {
				pArr.push({title: page, page: page, active: true});
			}
		} else if (PageNo < m_NumPages - m_NumOuterLinks - m_NumAdjacentLinks) {
			for (var page = 1; page <= m_NumOuterLinks; page++) {
				pArr.push({title: page, page: page, active: true});
			}
			if (m_NumOuterLinks > 0) {
				pArr.push({title: m_PageLinkSeparator, page: PageNo, active: false});
			}
			for (var page = PageNo - m_NumAdjacentLinks; page <= PageNo + m_NumAdjacentLinks; page++) {
				pArr.push({title: page, page: page, active: true});
			}
			if (m_NumOuterLinks > 0) {
				pArr.push({title: m_PageLinkSeparator, page: PageNo, active: false});
			}
			for (var page = m_NumPages - (m_NumOuterLinks - 1); page <= m_NumPages; page++) {
				pArr.push({title: page, page: page, active: true});
			}
		} else {
			for (var page = 1; page <= m_NumOuterLinks; page++) {
				pArr.push({title: page, page: page, active: true});
			}
			if (m_NumOuterLinks > 0) {
				pArr.push({title: m_PageLinkSeparator, page: PageNo, active: false});
			}
			for (var page = m_NumPages - (m_NumOuterLinks + (m_NumAdjacentLinks * 2)); page <= m_NumPages; page++) {
				pArr.push({title: page, page: page, active: true});
			}
		}
	}
	return pArr;
}

dmx.Formatters('object', {

	getDataViewPagination: function(object, outer, adjecent, separator) {
		if (!object.page && !object.pages) return [];
		return _getPagination(object.pages, object.page, outer, adjecent, separator);
	},

	getServerConnectPagination: function(object, outer, adjecent, separator) {
		if (!object.page && !object.page.total && !object.page.current) return [];
		return _getPagination(object.page.total, object.page.current, outer, adjecent, separator);
	},

	getFlowPagination: function(object, outer, adjecent, separator) {
		if (!object.page && !object.page.total && !object.page.current) return [];
		return _getPagination(object.page.total, object.page.current, outer, adjecent, separator);
	}

});

})();
