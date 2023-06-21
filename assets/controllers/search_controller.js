import { Controller } from 'stimulus';

export default class extends Controller {
  static targets = ['search_results'];

  /**
   * 
   * @param {*} event 
   * @return {Promise}
   */
  async searching(event) {
    const keywords = event.target.value.trim();

    if (keywords.length === 0) {
      this.search_resultsTarget.innerHTML = '';
      return;
    }

    try {
      const response = await fetch(`/search?keywords=${encodeURIComponent(keywords)}`);
      const searchResults = await response.json();

      const html = searchResults.map((result) => {
		const photosImg = result.photos.map((photo) => {
			return `<img src="${photo.url}" alt="${photo.name}">`;
		}).join('');
		
        return `
			
			<li>
				<a href="/place/${result.id}" class="bg-primary">
					<h3>${result.name}</h3>
					<p>${result.description}</p>
					${photosImg}
				</a>
			</li>
			
        `;
      }).join('');

      this.search_resultsTarget.innerHTML = html;

    } catch (error) {
      console.error('Une erreur s\'est produite lors de la recherche :', error);
    }
  }
}
