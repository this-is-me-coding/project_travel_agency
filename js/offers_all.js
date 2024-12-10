const URLqueryString = window.location.search;
const urlParams = new URLSearchParams(URLqueryString);
const page = urlParams.get('page');
const max_pages = document.querySelector('span[data-explore-max-pages]').innerHTML;

const offers_all_arrow_left = document.querySelector('.offers_all_arrow_left');
const offers_all_arrow_right = document.querySelector('.offers_all_arrow_right');

if(page==="1") {
    offers_all_arrow_left.setAttribute("style", "display: none;");
} else if (page===max_pages) {
    offers_all_arrow_right.setAttribute("style", "display: none;");
}

offers_all_arrow_left.addEventListener('click', () => {
    window.history.pushState({}, '', ("offers.php?page="+(parseInt(page)-1)));
    window.location.assign("offers.php?page="+(parseInt(page)-1));
});

offers_all_arrow_right.addEventListener('click', () => {
    window.history.pushState({}, '', ("offers.php?page="+(parseInt(page)+1)));
    window.location.assign("offers.php?page="+(parseInt(page)+1));
});