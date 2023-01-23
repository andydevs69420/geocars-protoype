function formatMoney (money) {
    let formatter = new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'PHP',
    });
    return formatter.format(money);
}