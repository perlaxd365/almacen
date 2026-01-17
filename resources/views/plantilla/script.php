<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://unpkg.com/akar-icons-fonts"></script>



</head>

<script>
    window.addEventListener('alert', event => {
        console.log(event.detail[0].type)
        Swal.fire({
            icon: event.detail[0].type,
            title: event.detail[0].title,
            text: event.detail[0].message,
            showConfirmButton: false,
            timer: 2000
        })
    })
</script>

<script>
    document.addEventListener('livewire:init', () => {
        
        Livewire.directive('sweet-confirm-pago', ({ el, directive, component, cleanup }) => {
            let content = directive.expression;

            // This regex splits the method given: eg. "delete(1)" to ['delete(1)', 'delete', '1']
            const regex = /([a-zA-Z_]*)\((['"][^'"]*['"]|\d+)\)/;

            const matches = content.match(regex);
            
            let onClick = e => {
                Swal.fire({
                    title: 'Are you sure?',
                    text: content,
                    icon: 'question',
                    iconColor: '#ef4444',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#aaa',
                    confirmButtonText: 'Yes, delete it!',
                    background: 'linear-gradient(to bottom, #fee2e2, #ffffff)',
                    customClass: {
                        popup: 'rounded-xl',
                    },
                }).then((result) => {
                    if (result.isConfirmed) {
                        console.log(directive);
                        //component.$wire.call('test')
                    }
                });
            }
        
            el.addEventListener('click', onClick, { capture: true })
        
            cleanup(() => {
                el.removeEventListener('click', onClick)
            })
        })
    })
</script>
