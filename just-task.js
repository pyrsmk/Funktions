const { task } = require('just-task')
const execa = require('execa')
const readline = require('readline-sync')

task('publish', async () => {
    const version = readline.question('Version: ')
    await execa('git', ['tag', version]).all.pipe(process.stdout)
    await execa('git', ['push']).all.pipe(process.stdout)
    await execa('git', ['push', '--tags']).all.pipe(process.stdout)
})
