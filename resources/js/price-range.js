import noUiSlider from 'nouislider';
import 'nouislider/dist/nouislider.css';

document.addEventListener('DOMContentLoaded', function() {
    const priceRange = document.getElementById('price-range');
    if (!priceRange) return;
    
    // Get the dynamic range values
    const rangeMin = parseFloat(priceRange.dataset.rangeMin);
    const rangeMax = parseFloat(priceRange.dataset.rangeMax);
    const startMin = parseFloat(priceRange.dataset.minPrice);
    const startMax = parseFloat(priceRange.dataset.maxPrice);
    
    noUiSlider.create(priceRange, {
        start: [startMin, startMax],
        connect: true,
        range: {
            'min': rangeMin,
            'max': rangeMax
        },
        format: {
            to: function (value) {
                return Math.round(value);
            },
            from: function (value) {
                return Math.round(value);
            }
        },
        // Add steps for smoother sliding
        step: Math.max(1, Math.floor((rangeMax - rangeMin) / 100))
    });

    const minPriceLabel = document.getElementById('minPriceLabel');
    const maxPriceLabel = document.getElementById('maxPriceLabel');

    priceRange.noUiSlider.on('update', function (values) {
        minPriceLabel.textContent = values[0];
        maxPriceLabel.textContent = values[1];
        applyFilters();
    });
});

function applyFilters() {
    const priceRange = document.getElementById('price-range');
    if (!priceRange?.noUiSlider) return;

    const values = priceRange.noUiSlider.get();
    const minPrice = parseFloat(values[0]);
    const maxPrice = parseFloat(values[1]);
    const brand = document.getElementById('brand').value.toLowerCase().trim();

    document.querySelectorAll('.product-card').forEach(product => {
        const price = parseFloat(product.getAttribute('data-price'));
        const productBrand = (product.getAttribute('data-brand') || '').toLowerCase();
        
        const matchesPrice = price >= minPrice && price <= maxPrice;
        const matchesBrand = !brand || productBrand.includes(brand);
        
        product.style.display = (matchesPrice && matchesBrand) ? 'block' : 'none';
    });

    updateSectionVisibility();
}

function updateSectionVisibility() {
    ['shopee', 'lazada', 'local'].forEach(source => {
        const section = document.querySelector(`[data-source="${source}"]`);
        if (!section) return;

        const productsGrid = section.querySelector('.grid');
        const visibleProducts = [...section.querySelectorAll('.product-card')]
            .filter(card => card.style.display !== 'none').length;

        if (visibleProducts === 0) {
            if (productsGrid) productsGrid.style.display = 'none';
            let noResults = section.querySelector('.no-results');
            if (!noResults) {
                noResults = document.createElement('div');
                noResults.className = 'no-results text-center py-8';
                noResults.innerHTML = '<p class="text-gray-500">No matching products found</p>';
                productsGrid.after(noResults);
            }
        } else {
            if (productsGrid) productsGrid.style.display = 'grid';
            const noResults = section.querySelector('.no-results');
            if (noResults) noResults.remove();
        }
    });
}

window.applyFilters = applyFilters; 