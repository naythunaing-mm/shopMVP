function rgbToHex(rgb) {
    // Extract the R, G, B values from the rgb() string
    const match = rgb.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);
    if (!match) {
        // Handle rgba() or other color formats if necessary
        return null; // Or throw an error
    }

    const r = parseInt(match[1]);
    const g = parseInt(match[2]);
    const b = parseInt(match[3]);

    // Convert each component to a two-digit hex string
    const toHex = (c) => {
        const hex = c.toString(16);
        return hex.length === 1 ? '0' + hex : hex;
    };

    return '#' + toHex(r) + toHex(g) + toHex(b);
}
function removeColor(e) {
    let productColors = document.getElementById('colors'); // red,blue
    let colors = productColors.value.split(',');
    colors = colors.filter(color => color !== rgbToHex(e.target.style.backgroundColor));
    productColors.value = colors.join(',');
    e.target.remove();
}
function createColorElement(){
    let productElement = document.createElement('div');
    productElement.style.width = "20px";
    productElement.style.height = "20px";
    productElement.style.display = "inline-block";
    productElement.style.margin = "5px";
    productElement.innerHTML = " ";
    return productElement;
}
window.onload = function() {
    const colorElement = createColorElement();
    let productColorsContainer = document.getElementById('product-colors'); // just a container to render colors
    let productColors = document.getElementById('colors'); // red,blue
    let colors = productColors.value.split(',');
    for(let color of colors) {
        const cloneColorElement = colorElement.cloneNode(true);
        console.log(cloneColorElement);
        cloneColorElement.style.backgroundColor = color;
        cloneColorElement.onclick = removeColor;
        productColorsContainer.appendChild(cloneColorElement);
    }
    document.getElementById('add-product-color').addEventListener('click', function(e) {
        const newColor = document.getElementById('color-picker').value;
        colors.push(newColor);
        const cloneColorElement = colorElement.cloneNode(true);
        cloneColorElement.style.backgroundColor = newColor;
        cloneColorElement.onclick = removeColor;
        productColorsContainer.appendChild(cloneColorElement);
        productColors.value = colors.join(',');
        e.preventDefault();
    });
}
