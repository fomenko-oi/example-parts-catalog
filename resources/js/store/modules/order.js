const state = {
  delivery: null,
  comment: ''
};

// getters
const getters = {
    isExecutor(state) {
        return state.user && state.user.type === 'executor';
    },
    isCustomer(state) {
        return state.user && state.user.type === 'customer';
    }
};

// actions
const actions = {
};

// mutations
const mutations = {
    setUser(context, user) {
        user = user || {};

        user.avatar = null;
        user.be_notified = true;
        user.dark_mode = true;
        user.is_online = true;
        user.name = user.first_name;
        user.slug = user.id;

        context.user = user;
    },
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}
