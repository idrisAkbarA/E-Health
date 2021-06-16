export default function (context) {
    console.log('is logged in', context.$auth.loggedIn);
    if (!context.$auth.loggedIn) {
        context.redirect('/');
        return
    }
    if (context.$auth.user.role != "Kasir") {
        context.error({ statusCode: 401, message: 'Unauthorized' });
    }
}