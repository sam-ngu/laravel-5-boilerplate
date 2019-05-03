import {mount} from '@vue/test-utils'
import BaseUserManagement from '../../../../resources/js/backend/components/user-management/BaseUserManagement'
import BaseTableLayout from '../../../../resources/js/backend/components/user-management/user-table/BaseTableLayout'

describe('UserManagement', function () {
    const base = mount(BaseUserManagement);

    const table = mount(BaseTableLayout);


    it('display users in table', function () {
        expect(table.vm.users).toBeDefined()
    });

    it('open create page', function () {

    });

    it('open show page', function () {

    });

    it('');
})



