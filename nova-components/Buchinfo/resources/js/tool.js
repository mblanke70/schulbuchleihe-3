Nova.booting((Vue, router, store) => {
    router.addRoutes([
        {
            name: 'buchinfo',
            path: '/buchinfo',
            component: require('./components/Tool'),
        },
    ])
})
