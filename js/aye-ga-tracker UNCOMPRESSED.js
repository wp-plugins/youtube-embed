function recordOutboundLink(category, action, label) {
    _gaq.push(['_trackEvent', category, action, label]);
}