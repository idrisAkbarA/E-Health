export default function (context) {
    if (context.$auth.loggedIn) {
        switch (context.$auth.user.role) {
            case "Admin":
                context.redirect(`/admin/${context.$auth.user.id}/dashboard`);
                break;
            case "Apoteker":
                context.redirect(`/apoteker/${context.$auth.user.id}/dashboard`);
                break;
            case "Dokter":
                context.redirect(`/dokter/${context.$auth.user.id}/dashboard`);
                break;
            case "Kepala Instansi":
                context.redirect(`/kepala-instansi/${context.$auth.user.id}/dashboard`);
                break;
            case "Pelayanan":
                context.redirect(`/pelayanan/${context.$auth.user.id}/dashboard`);
                break;

            default:
                break;
        }

    }
}