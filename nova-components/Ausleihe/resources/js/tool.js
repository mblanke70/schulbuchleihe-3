Nova.booting((Vue, router, store) => {
    router.addRoutes([
        {
            name: 'ausleihe',
            path: '/ausleihe',
            component: require('./components/Tool'),
        },
    ])
})
