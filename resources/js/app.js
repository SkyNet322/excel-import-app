import './bootstrap';

import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    encrypted: true,
});

window.Echo.connector.pusher.connection.bind('connected', () => {
    console.log('Подключено к Pusher');
});

window.Echo.channel('batch-channel')
    .listen('.batch.completed', (e) => {
        console.log('Получено событие batch.completed:', e);
        if (e.message) {
            alert('Сообщение: ' + e.message);
        }
    });