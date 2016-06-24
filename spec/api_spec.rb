require 'net/http'
require 'json'

describe "API tests" do

	before(:each) { 
		@root_url = 'http://silex.localhost'
	}

	it "returns hello instructions" do
		uri = URI(@root_url)
		response = Net::HTTP.get(uri)
		expect(response).to eq 'Try /hello/:name'
	end

	it "returns hello greeting for your name" do
		['Joe', 'Jane', 'Jake'].each do |name|
			uri = URI("#{@root_url}/hello/#{name}")
			response = Net::HTTP.get(uri)
			expect(response).to eq "Hello #{name}"
		end
	end

	it "returns 404 for non existing twitter screen name" do
		uri = URI("#{@root_url}/histogram/non3xist1ng")
		response = Net::HTTP.get_response(uri)
		expect(response.code.to_i).to eq 404
	end

	it "returns valid data from twitter" do

		['ferrari', 'bigcommerce'].each do |screen_name|
			uri = URI("#{@root_url}/histogram/#{screen_name}")
			response = Net::HTTP.get_response(uri)
			expect(response.code.to_i).to eq 200
			data = JSON.parse(response.body)
			#should have all the hours
			expect(data.length).to eq 24
			#the sum of tweets from all hours should match up
			total = 0
			data.map { |hour, value| total+=value }
			expect(total).to eq 200
			data.each do |hour, value|
				expect(hour.to_i).to be < 24
				expect(hour.to_i).to be >= 0
			end
		end
		
	end


end