
class Task {
    constructor(data) {
        this.id = data.id || '';
        this.user_id = data.user_id || '';
        this.date = data.date || '';
        this.start = data.start || 0;
        this.end = data.end || '';
        this.worked_hours = data.worked_hours || '';
    }
}
export default Task;
