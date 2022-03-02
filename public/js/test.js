function test333() {
    return 333;
}

function test444() {
    value = this.test333();
    return value;
}

if (typeof module !== 'undefined') module.exports = {
    test333,
    test444,
};