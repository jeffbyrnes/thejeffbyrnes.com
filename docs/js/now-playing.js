/* ********************************************************************** */
/* OLD SCHOOL CURRENT PLAYING STUFF */
const LFM_API = 'https://ws.audioscrobbler.com/2.0/'
// Get one at https://secure.last.fm/login?next=/api/account/create
const LFM_KEY = 'ce8a26c8204cd9994cb27278d682efe3'
const LFM_USER = 'jeffbyrnes'

async function getNowPlaying() {
  const recentTracksUrl = `${LFM_API}?method=user.getrecenttracks&user=${LFM_USER}&api_key=${LFM_KEY}+&format=json&limit=1`
  let httpRequest

  try {
    httpRequest = await fetch(recentTracksUrl)
  } catch (error) {
    console.error(`Something’s gone wrong: ${error.message}`)
  }

  if (httpRequest.ok) {
    const response = await httpRequest.json()

    console.log(response)

    const currentTrack = response.recenttracks.track[0]

    // Check if it's the same, if not then rerender
    if (
      !window.nowPlaying ||
      window.nowPlaying.mbid !== currentTrack.mbid
    ) {
      window.nowPlaying = currentTrack
      renderNowPlaying(currentTrack)
    }
    setTimeout(getNowPlaying, 60 * 1000)
  } else {
    console.error(`HTTP error! status: ${httpRequest.status}`)
  }
}

function renderNowPlaying(track) {
  const currently = track['@attr'] && track['@attr'].nowplaying === 'true'
  const imageurl = track.image.slice(-1)[0]['#text']
  const date = new Date(track.date.uts * 1000)
  const datetime = date.toLocaleString()

  let nowPlaying = null
  let nowPlayingContainer = null

  console.log(track)

  if (nowPlaying) {
    nowPlaying.remove()
  }

  nowPlayingContainer = document.getElementsByClassName('now-playing-container')[0]

  nowPlaying = document.createElement('a')

  nowPlaying.className = 'now-playing'
  nowPlaying.innerHTML = `<h1 class="np-heading">${(currently ? 'Now Playing' : 'Latest Track')}</h1>`

  const nowPlayingImage = document.createElement('img')

  nowPlayingImage.src = imageurl

  nowPlaying.append(nowPlayingImage)

  // Add more stuff to the display
  const metadata = document.createElement('div')

  metadata.setAttribute('class', 'np-metadata')

  metadata.innerHTML =
    `<span class="np-title"><strong>${track.name}</strong></span>` +
    `<span class="np-artist">${track.artist['#text']}</span>` +
    (currently
      ? '<span class="np-date"><span class="breather">◉</span> Currently Playing</span>'
      : `<span class="np-date">${datetime}</span>`)

  nowPlaying.append(metadata)

  nowPlaying.setAttribute('href', track.url)

  nowPlayingContainer.append(nowPlaying)

  setTimeout(function () {
    nowPlaying.setAttribute('class', 'now-playing loaded')
  }, 100)
}

window.addEventListener('load', (event) => {
  getNowPlaying()
})
