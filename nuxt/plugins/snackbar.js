export default (context, inject) => {
    var snackbar = function (color, message, value) {
        var data = {
            color,
            message,
            value
        }
        context.store.commit('snackbar/set', data);
        console.log('snackbar', data);
    }
    inject('snackbar', snackbar)
}