// Client-side event search and pagination.
(function () {
    var searchInput = document.getElementById('eventSearch');
    var eventGrid = document.getElementById('eventGridList');
    var pagination = document.getElementById('eventPagination');
    var noResults = document.getElementById('eventNoResults');

    if (!searchInput || !eventGrid || !pagination || !noResults) return;

    var cards = Array.prototype.slice.call(eventGrid.querySelectorAll('.event_card'));
    var perPage = 8;
    var currentPage = 1;

    function render() {
        var query = searchInput.value.trim().toLowerCase();
        var matches = cards.filter(function (card) {
            return (card.getAttribute('data-search') || '').indexOf(query) !== -1;
        });
        var pageCount = Math.ceil(matches.length / perPage);
        var start = (currentPage - 1) * perPage;
        var visibleCards = matches.slice(start, start + perPage);

        cards.forEach(function (card) {
            var isVisible = visibleCards.indexOf(card) !== -1;
            card.hidden = !isVisible;

            if (isVisible) {
                // Remove the scroll-reveal state so it cannot keep filtered cards hidden.
                card.removeAttribute('data-reveal');
                card.classList.remove('event_search_enter');
                void card.offsetWidth;
                card.classList.add('event_search_enter');
            } else {
                card.classList.remove('event_search_enter');
            }
        });

        noResults.style.display = matches.length ? 'none' : 'block';
        pagination.innerHTML = '';

        for (var page = 1; page <= pageCount; page++) {
            (function (pageNumber) {
                var button = document.createElement('button');
                button.type = 'button';
                button.className = 'event_page_button' + (pageNumber === currentPage ? ' active' : '');
                button.textContent = pageNumber;
                button.setAttribute('aria-label', 'Page ' + pageNumber);
                if (pageNumber === currentPage) button.setAttribute('aria-current', 'page');
                button.addEventListener('click', function () {
                    currentPage = pageNumber;
                    render();
                });
                pagination.appendChild(button);
            })(page);
        }
    }

    searchInput.addEventListener('input', function () {
        currentPage = 1;
        render();
    });

    render();
})();
