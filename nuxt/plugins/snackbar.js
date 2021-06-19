export default (context, inject) => {
    var snackbar = function (color, message) {
        var data = {
            color,
            message,
            value: true
        }
        context.store.commit('snackbar/set', data);
        console.log('snackbar', data);
        var newData = {
            color,
            message,
            value: false
        }
        setTimeout(() => {
            context.store.commit('snackbar/set', newData);

        }, 2000);
        // data.value = false
        // context.store.commit('snackbar/set', data);
    }
    inject('snackbar', snackbar)
}