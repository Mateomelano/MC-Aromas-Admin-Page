document.addEventListener('DOMContentLoaded', () => {
    const copyButton = document.getElementById('copyButton');
    const clearButton = document.getElementById('clearButton');
    const notebook = document.getElementById('notebook');

    let isInList = false; // Indica si estamos dentro de una lista

    notebook.addEventListener('keydown', (e) => {
        if (e.key === 'Enter') {
            e.preventDefault();
            const text = notebook.value.trim();
            let lines = text.split('\n');
            let lastLine = lines[lines.length - 1].trim(); // Eliminamos espacios extra

            if (lastLine === '') return; // Evita líneas vacías

            if (isUppercaseHeader(lastLine)) {
                // Si es un nuevo encabezado en mayúsculas con ":", lo sacamos de la lista
                isInList = false;

                // Si la línea comienza con "- ", lo eliminamos antes de agregar el encabezado
                if (lastLine.startsWith('- ')) {
                    lastLine = lastLine.substring(2); // Removemos el "- "
                }

                // Reemplazamos la última línea con el encabezado limpio
                lines[lines.length - 1] = `\n${lastLine}`;
                notebook.value = lines.join('\n') + '\n- '; // <-- Agregamos un guion para la siguiente línea
                isInList = true; // <-- Activa la lista de inmediato
            } 
            else if (isInList) {
                // Si estamos dentro de una lista, agrega un nuevo elemento con guion
                notebook.value += `\n- `;
            } 
            else {
                // Si no estamos en una lista, simplemente agrega una nueva línea
                notebook.value += `\n`;
            }
        }
    });

    copyButton.addEventListener('click', () => {
        notebook.select();
        document.execCommand('copy');

        copyButton.textContent = '¡Texto Copiado!';
        setTimeout(() => copyButton.textContent = 'Copiar Texto', 2000);
    });

    clearButton.addEventListener('click', () => {
        notebook.value = '';
        isInList = false;
    });

    function isUppercaseHeader(text) {
        // Detecta si es un encabezado en mayúsculas que termina en ":"
        return text === text.toUpperCase() && text.endsWith(':') && /[A-Z]/.test(text);
    }
});
