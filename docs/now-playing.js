/* ********************************************************************** */
/* OLD SCHOOL CURRENT PLAYING STUFF */
const LFM_API = 'https://ws.audioscrobbler.com/2.0/'
// Get one at https://secure.last.fm/login?next=/api/account/create
const LFM_KEY = 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx'
const LFM_USER = 'trisweb'

function getNowPlaying () {
  const recentTracksUrl = `${LFM_API}?method=user.getrecenttracks&user=${LFM_USER}&api_key=${LFM_KEY}+&format=json&limit=1`
  let httpRequest

  if (window.XMLHttpRequest) {
    httpRequest = new XMLHttpRequest()
  } else if (window.ActiveXObject) {
    httpRequest = new ActiveXObject('Microsoft.XMLHTTP')
  }

  httpRequest.onreadystatechange = function () {
    if (httpRequest.readyState === XMLHttpRequest.DONE) {
      if (httpRequest.status === 200) {
        // All set
        const response = JSON.parse(httpRequest.responseText)

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
        console.log('There was a problem with the last.fm request.')
      }
    }
  }
  httpRequest.open('GET', recentTracksUrl, true)
  httpRequest.send()
}

let nowPlayingNode = null

function renderNowPlaying (track) {
  console.log(track)

  if (nowPlayingNode) {
    nowPlayingNode.remove()
  }

  nowPlayingNode = document.createElement('a')

  nowPlayingNode.setAttribute('class', 'now-playing')

  const imageurl = track.image.slice(-1)[0]['#text']
  const nowPlayingImage = document.createElement('img')

  nowPlayingImage.setAttribute('src', imageurl)

  nowPlayingNode.appendChild(nowPlayingImage)

  // Add more stuff to the display
  const currently = track['@attr'] && track['@attr'].nowplaying === 'true'
  const metadata = document.createElement('div')

  metadata.setAttribute('class', 'np-metadata')

  metadata.innerHTML =
    `<span class="np-heading">${(currently ? 'Now Playing' : 'Latest Track')}</span>` +
    `<span class="np-title"><strong>${track.name}</strong></span>` +
    `<span class="np-artist">${track.artist['#text']}</span>` +
    (currently
      ? '<span class="np-date"><span class="breather">◉</span> Currently Playing</span>'
      : `<span class="np-date">${track.date['#text']}</span>`)

  nowPlayingNode.appendChild(metadata)

  nowPlayingNode.setAttribute('href', track.url)

  document.body.appendChild(nowPlayingNode)

  setTimeout(function () {
    nowPlayingNode.setAttribute('class', 'now-playing loaded')
  }, 100)
}

window.addEventListener('load', (event) => {
  getNowPlaying()
})
