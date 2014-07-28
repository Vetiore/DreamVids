<?php

require_once SYSTEM.'controller.php';
require_once SYSTEM.'actions.php';
require_once SYSTEM.'view_response.php';
require_once SYSTEM.'redirect_response.php';
require_once SYSTEM.'json_response.php';

require_once MODEL.'user_channel.php';
require_once MODEL.'channel_post.php';
require_once MODEL.'video.php';

class ChannelPostController extends Controller {

	public function __construct() {
		$this->denyAction(Action::INDEX);
	}

	public function get($id, $request) {
		if(ChannelPost::exists($id)) {
			$post = ChannelPost::find($id);

			if(!$request->acceptsJson())
				return new RedirectResponse(WEBROOT.'channel/'.$post->channel_id.'/social');

			$postData = array(
				'id' => $post->id,
				'channel_id' => $post->channel_id,
				'content' => $post->content,
				'timestamp' => $post->timestamp
			);

			return new JsonResponse($postData);
		}
		else {
			return Utils::getNotFoundResponse();
		}
	}

	// "GET /posts/:channel-id" -- Gets the posts on channel 'channel-id'
	public function channel($id, $request) {
		$channel = UserChannel::exists($id) ? UserChannel::find($id) : UserChannel::find_by_name($id);

		if(is_object($channel)) {
			if(!$request->acceptsJson())
				return new RedirectResponse(WEBROOT.'channel/'.$channel->id.'/social');

			$posts = $channel->getPostedMessages();
			$postsArray = Utils::objectToArray($posts);
			$postsJsonArray = array();

			foreach($postsArray as $post) {
				$postsJsonArray[] = array(
					'id' => $post->id,
					'channel_id' => $post->channel_id,
					'content' => $post->content,
					'timestamp' => $post->timestamp
				);
			}

			return new JsonResponse($postsJsonArray);
		}
		else
			return Utils::getNotFoundResponse();
	}

	public function create($request) {
		$req = $request->getParameters();

		if(isset($req['post-message-submit'], $req['channel'], $req['post-content']) && Session::isActive()) {
			$channelId = $req['channel'];
			$channel = UserChannel::exists($channelId) ? UserChannel::find($channelId) : UserChannel::find_by_name($channelId);

			if(is_object($channel) && $channel->belongToUser(Session::get()->id)) {
				$postContent = Utils::secure($req['post-content']);
				$post = $channel->postMessage($postContent);

				$postData = array(
					'id' => $post->id,
					'channel_id' => $post->channel_id,
					'content' => $post->content,
					'timestamp' => $post->timestamp
				);

				return new JsonResponse($postData);
			}
		}

		return new Response(500);
	}

	public function update($id, $request) {

	}

	public function destroy($id, $request) {

	}


	// Denied actions
	public function index($request) {}

}