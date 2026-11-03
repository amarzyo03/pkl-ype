@php
    $toastNotifications = [];

    foreach ([
        'success' => 'success',
        'error' => 'error',
        'failed' => 'error',
        'warning' => 'warning',
        'info' => 'info',
        'status' => 'info',
        'message' => 'info',
    ] as $sessionKey => $type) {
        $message = session($sessionKey);

        if (is_string($message) && trim($message) !== '') {
            $toastNotifications[] = ['type' => $type, 'message' => $message];
        } elseif (is_array($message)) {
            foreach ($message as $item) {
                if (is_string($item) && trim($item) !== '') {
                    $toastNotifications[] = ['type' => $type, 'message' => $item];
                }
            }
        }
    }

    foreach (($errors ?? collect())->all() as $message) {
        $toastNotifications[] = ['type' => 'error', 'message' => $message];
    }
@endphp

<div class="toast-container" data-toast-container aria-live="polite" aria-atomic="false">
    @foreach ($toastNotifications as $notification)
        <div
            class="toast"
            data-toast
            data-toast-type="{{ $notification['type'] }}"
            data-toast-message="{{ $notification['message'] }}"
            hidden
        ></div>
    @endforeach
</div>
