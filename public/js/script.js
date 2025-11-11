let cart = [];

function addToCart(name, price) {
    cart.push({ name, price });
    alert(`${name} is toegevoegd aan je winkelwagen.`);
    console.log(cart);
}
