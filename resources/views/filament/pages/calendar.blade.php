<x-filament-panels::page>
    <div class="text-sm text-gray-600 dark:text-gray-400">
        Visualiza todos los eventos de la campaña. Puedes cambiar entre vista mensual, semanal y diaria.
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // 👈 Forzar estilos en los eventos de FullCalendar
                function fixEventLayout() {
                    const events = document.querySelectorAll('.fc-daygrid-event');

                    events.forEach(function(event) {
                        // El contenedor del evento
                        event.style.display = 'block';
                        event.style.overflow = 'hidden';
                        event.style.textOverflow = 'ellipsis';
                        event.style.whiteSpace = 'nowrap';
                        event.style.padding = '2px 4px';
                        event.style.lineHeight = '1.3';

                        // El título
                        const title = event.querySelector('.fc-event-title');
                        if (title) {
                            title.style.display = 'block';
                            title.style.overflow = 'hidden';
                            title.style.textOverflow = 'ellipsis';
                            title.style.whiteSpace = 'nowrap';
                            title.style.fontSize = '0.7rem';
                            title.style.fontWeight = '600';
                            title.style.lineHeight = '1.2';
                            title.style.padding = '0';
                            title.style.margin = '0';
                        }

                        // La hora
                        const time = event.querySelector('.fc-event-time');
                        if (time) {
                            if (window.innerWidth < 768) {
                                time.style.display = 'none';
                            } else {
                                time.style.display = 'inline-block';
                                time.style.fontSize = '0.7rem';
                                time.style.fontWeight = '700';
                                time.style.marginRight = '4px';
                            }
                        }
                    });
                }

                // Ejecutar al cargar
                setTimeout(fixEventLayout, 500);
                setTimeout(fixEventLayout, 1500);

                // Ejecutar al cambiar de vista
                const observer = new MutationObserver(function(mutations) {
                    fixEventLayout();
                });

                const calendarEl = document.querySelector('.fc');
                if (calendarEl) {
                    observer.observe(calendarEl, {
                        childList: true,
                        subtree: true,
                    });
                }

                // Ejecutar al redimensionar
                window.addEventListener('resize', fixEventLayout);
            });
        </script>
    @endpush
</x-filament-panels::page>
