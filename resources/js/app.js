import './bootstrap';
import '../../vendor/masmerise/livewire-toaster/resources/js';
import { initTheme, toggleTheme, watchSystemTheme } from './theme';

initTheme();
watchSystemTheme();

window.toggleTheme = toggleTheme;


