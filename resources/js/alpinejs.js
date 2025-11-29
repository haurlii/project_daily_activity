import Alpine from "alpinejs";
import persist from "@alpinejs/persist";
import focus from "@alpinejs/focus";

Alpine.plugin([persist, focus]);
window.Alpine = Alpine;
Alpine.start();
