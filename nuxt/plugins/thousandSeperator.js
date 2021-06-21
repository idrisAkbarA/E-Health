export default (context, inject) => {
    var thousandSeperator = function (number) {
        if (typeof (number) == "number") {
            return number.toLocaleString('en')
        } else {
            return parseFloat(number).toLocaleString('en')
        }
    }
    inject('numberify', thousandSeperator)
}