function reloadPage(view, page) {
    if($('#search-keyword').val() != '') {
        return true;
    }
    window.location.replace(`${DOMAIN}/${view}/${page}/page=1`)
    return false
}