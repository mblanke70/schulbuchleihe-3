Nova.booting((Vue, router, store) => {
    router.addRoutes([
        {
            name: 'rueckgabe',
            path: '/rueckgabe',
            component: require('./components/Tool'),
        },
    ])
})
