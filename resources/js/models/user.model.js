

class User {
    constructor(data) {
        this.id = data.id || '';
        this.name = data.name || '';
        this.surname = data.surname || '';
        this.preferred_working_hours_per_day = data.preferred_working_hours_per_day || 0;
        this.username = data.username || '';
        this.password = data.password || '';
        this.user_type = data.user_type || 0;
    }
}
export default User;
