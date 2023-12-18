module.exports = {
    rules: {
        'linebreak-style': [
          'error',
          process.platform === 'win32' ? 'windows' : 'unix',
        ],
        'no-console': 'off'
    },
}