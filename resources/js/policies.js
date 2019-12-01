const policies = {
    modify (user, model) {
        return user.id === model.user_idl
    },

    accept (user, answer) {
        return user.id === answer.question.user_id;
    }
};

Vue.prototype.authorize = function (policy, model) {
    if ( ! window.Auth.signedIn) return false;

    if (typeof policy === 'string' && typeof model === 'object') {
        const user = window.Auth.user;

        return policies[policy] (user, model);
        // authorize ('modify', answer) becomes modify (user, answer)
    }
};
