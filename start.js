const { spawn } = require('child_process');

function serve() {
    const shell = spawn('php', ['artisan', 'serve'], { cwd: "./laravel/" });

    shell.stdout.on('data', (data) => {
        console.log(`%cLaravel: ${data}`, "color: yellow");
    });

    shell.stderr.on('data', (data) => {
        console.error(`Laravel: ${data}`);
    });

    shell.on('close', (code) => {
        console.log(`child process exited with code ${code}`);
    });
}
function websocket() {
    const shell = spawn('php', ['artisan', 'websockets:serve'], { cwd: "./laravel/" });

    shell.stdout.on('data', (data) => {
        // console.log(`Websocket: ${data}`);
        console.log(`%cWebsocket: ${data}`, "color: orange");
    });

    shell.stderr.on('data', (data) => {
        console.error(`stderr: ${data}`);
    });

    shell.on('close', (code) => {
        console.log(`child process exited with code ${code}`);
    });
}
function nuxtDevServer() {
    const shell = spawn('npm.cmd', ['run', 'dev'], { cwd: "./nuxt/" });

    shell.stdout.on('data', (data) => {
        console.log(`%cNuxt: ${data}`, "color: green");
    });

    shell.stderr.on('data', (data) => {
        console.error(`stderr: ${data}`);
    });

    shell.on('close', (code) => {
        console.log(`child process exited with code ${code}`);
    });
}

serve();
websocket();
nuxtDevServer();
