import VueRouter from 'vue-router'


const router = new VueRouter({
    routes: [
        {
            path: '/',
            component: DashboardContainer,
            name: 'home',

        },

        // {
        //     path: '/backtest/:backtest_id',
        //     name: 'backtest-details',
        //     component: BacktestDetails,
        //     // props: true,
        // }

    ],
});

router.beforeEach(function(to, from, next){
    // if entering control area, check if user is admin and prompt for entering password

    // if(to.matched.some(record => {
    //     console.log(record)
    // }))

    //

    next()
});

export default router
