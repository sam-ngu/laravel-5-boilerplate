import BaseUserManagement from '../../../backend/components/user-management/BaseUserManagement'
import UserManagementShow from '../../../backend/components/user-management/UserManagementShow'


let baseBreadcrumb = [
    {
        text: 'User Management',
        disabled: true,
        href: '/admin/#/auth/user',
    },
];


const user = [
    {
        path: '/auth/user',
        component: BaseUserManagement,
        name: 'user-management',
        meta: {
            breadcrumb: baseBreadcrumb,
        },
        children: [
            {
                path: '/auth/user/:id',
                name: 'show',
                component: UserManagementShow,
                props: true,
                meta: {
                    breadcrumb: baseBreadcrumb.concat({
                        text: "User Details",
                        disabled: true,
                        href: '',
                    })
                }

            }
        ]

    },

];

export {user}
