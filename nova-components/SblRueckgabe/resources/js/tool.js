Nova.booting((Vue, router, store) => {
    router.addRoutes([
        {
            name: 'sbl-rueckgabe',
            path: '/sbl-rueckgabe',
            component: require('./components/Tool'),
        },
    ])
})
